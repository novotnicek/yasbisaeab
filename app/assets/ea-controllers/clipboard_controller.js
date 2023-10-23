import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    async copy() {
        try {
            await navigator.clipboard.writeText(this.element.dataset.string);
            console.log('Copied to clipboard');
        } catch (err) {
            console.error('Failed to copy: ', err);
        }
    }
}
