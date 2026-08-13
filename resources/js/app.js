import './bootstrap';
import './dashboards';
import './address-autocomplete';
import './solar-designer';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

window.propertyWizard = function(config) {
    return {
        step: config.initialStep || 1,
        ownerName: config.initialOwnerName || '',
        ownerEmail: config.initialEmail || '',
        ownerPhone: config.initialPhone || '',
        propertyName: config.initialPropertyName || '',
        status: config.initialStatus || 'Pending',
        address: config.initialAddress || '',
        city: config.initialCity || '',
        province: config.initialProvince || '',
        postal_code: config.initialPostalCode || '',
        country: config.initialCountry || 'Philippines',
        latitude: config.initialLatitude || '',
        longitude: config.initialLongitude || '',
        placeId: config.initialPlaceId || '',
        formattedAddress: '',
        mapImageUrl: config.mapImageUrl || '',
        mapMessage: 'Search for the address in the previous step to place it on the map.',
        init() {
            this.selectStep(this.step);
        },

        /** True once the address step produced usable coordinates. */
        get hasCoordinates() {
            return this.latitude !== '' && this.longitude !== '' &&
                this.latitude !== null && this.longitude !== null;
        },

        /** Satellite preview, served through our own proxy route. */
        get mapPreviewSrc() {
            if (!this.hasCoordinates || !this.mapImageUrl) {
                return '';
            }

            const url = new URL(this.mapImageUrl, window.location.origin);
            url.searchParams.set('lat', this.latitude);
            url.searchParams.set('lng', this.longitude);
            url.searchParams.set('zoom', 19);
            url.searchParams.set('size', 'large');

            return url.toString();
        },

        get googleMapsUrl() {
            if (!this.hasCoordinates) {
                return '#';
            }

            return `https://www.google.com/maps/search/?api=1&query=${this.latitude},${this.longitude}`;
        },
        selectStep(step) {
            this.step = step;
            window.requestAnimationFrame(() => {
                document.querySelectorAll('[data-property-wizard-panel]').forEach((panel) => {
                    const visible = Number(panel.dataset.propertyWizardPanel) === this.step;
                    panel.hidden = !visible;
                    panel.style.setProperty('display', visible ? 'block' : 'none', 'important');
                });
            });
        },
        next() {
            this.selectStep(Math.min(this.step + 1, 5));
        },
        prev() {
            this.selectStep(Math.max(this.step - 1, 1));
        },
        applyLocation(location) {
            this.address = location.address || this.address;
            this.city = location.city || '';
            this.province = location.province || '';
            this.postal_code = location.postalCode || '';
            this.country = location.country || 'Philippines';
            this.latitude = location.latitude ?? this.latitude;
            this.longitude = location.longitude ?? this.longitude;
            this.placeId = location.placeId || '';
            this.formattedAddress = location.formattedAddress || '';
            this.mapMessage = 'Location confirmed. Solar and weather data are fetched when you save.';
        },
    };
};

Alpine.start();
