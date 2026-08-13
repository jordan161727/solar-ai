/**
 * Address autocomplete backed by our own /places/* routes.
 *
 * The Google key stays on the server; this only talks to the Laravel app.
 * If the lookup fails the plain text inputs still work, so the form degrades
 * rather than breaking.
 *
 * Chosen places are handed to the wizard through the existing
 * `property-location-selected` window event rather than by writing to the
 * parent Alpine scope, which keeps the two components decoupled.
 */
window.addressAutocomplete = function (config = {}) {
    return {
        term: config.initialAddress || '',
        suggestions: [],
        open: false,
        loading: false,
        error: '',
        highlighted: -1,
        sessionToken: null,
        debounceTimer: null,
        /** True once a real place was picked (vs. free typing). */
        resolved: Boolean(config.initialPlaceId),

        urls: {
            autocomplete: config.autocompleteUrl,
            details: config.detailsUrl,
        },

        init() {
            this.newSession();
        },

        /** Places bills per session; a session ends when details() is called. */
        newSession() {
            this.sessionToken =
                window.crypto?.randomUUID?.() ??
                String(Date.now()) + Math.random().toString(16).slice(2);
        },

        onInput(value) {
            this.term = value;
            this.resolved = false;
            this.error = '';

            clearTimeout(this.debounceTimer);

            if (this.term.trim().length < 3) {
                this.suggestions = [];
                this.open = false;
                return;
            }

            this.debounceTimer = setTimeout(() => this.search(), 250);
        },

        async search() {
            this.loading = true;

            try {
                const url = new URL(this.urls.autocomplete, window.location.origin);
                url.searchParams.set('q', this.term);
                url.searchParams.set('session', this.sessionToken);

                const response = await fetch(url, {
                    headers: { Accept: 'application/json' },
                });

                if (!response.ok) {
                    throw new Error('Lookup failed');
                }

                const data = await response.json();

                this.suggestions = data.suggestions || [];
                this.highlighted = -1;
                this.open = this.suggestions.length > 0;
            } catch (e) {
                this.suggestions = [];
                this.open = false;
                this.error = 'Address lookup is unavailable — you can type the address manually.';
            } finally {
                this.loading = false;
            }
        },

        async choose(suggestion) {
            this.open = false;
            this.loading = true;
            this.error = '';

            try {
                const url = new URL(this.urls.details, window.location.origin);
                url.searchParams.set('place_id', suggestion.place_id);
                url.searchParams.set('session', this.sessionToken);

                const response = await fetch(url, {
                    headers: { Accept: 'application/json' },
                });

                if (!response.ok) {
                    throw new Error('Details failed');
                }

                const place = await response.json();

                this.term = place.address || '';
                this.resolved = true;

                // The wizard owns every address field — hand the place to it.
                window.dispatchEvent(
                    new CustomEvent('property-location-selected', {
                        detail: {
                            address: place.address,
                            city: place.city,
                            province: place.province,
                            postalCode: place.postal_code,
                            country: place.country,
                            latitude: place.latitude,
                            longitude: place.longitude,
                            placeId: place.place_id,
                            formattedAddress: place.formatted_address,
                        },
                    })
                );
            } catch (e) {
                this.error = 'Could not load that address. Please try another.';
            } finally {
                this.loading = false;
                // A details call closes the billing session.
                this.newSession();
            }
        },

        onKeydown(event) {
            if (!this.open || this.suggestions.length === 0) {
                return;
            }

            if (event.key === 'ArrowDown') {
                event.preventDefault();
                this.highlighted = (this.highlighted + 1) % this.suggestions.length;
            } else if (event.key === 'ArrowUp') {
                event.preventDefault();
                this.highlighted =
                    (this.highlighted - 1 + this.suggestions.length) % this.suggestions.length;
            } else if (event.key === 'Enter' && this.highlighted >= 0) {
                event.preventDefault();
                this.choose(this.suggestions[this.highlighted]);
            } else if (event.key === 'Escape') {
                this.open = false;
            }
        },
    };
};
