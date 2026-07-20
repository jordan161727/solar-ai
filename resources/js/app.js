import './bootstrap';
import './dashboards';

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
        mapMessage: 'Ready for API lookup.',
        init() {
            this.selectStep(this.step);
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
        lookupCoordinates() {
            if (!this.address) {
                this.mapMessage = 'Enter the address in step 3 first.';
                return;
            }
            this.mapMessage = 'API lookup stub: replace with your address lookup integration.';
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
            this.mapMessage = 'Location selected. Solar and weather data will be fetched when you save.';
        },
    };
};

Alpine.start();
