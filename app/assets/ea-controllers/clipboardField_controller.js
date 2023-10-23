import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        this.element.querySelector('.form-widget input').style.display = 'inline-block';
        this.element.querySelector('.form-widget input').style.width = 'calc(100% - 3em)';

        const icon = document.createElement('i');
        icon.classList.add('action-icon', 'fa', 'fa-clipboard');

        const copyButton = document.createElement('div');
        copyButton.classList.add('btn', 'btn-secondary', 'float-end');
        copyButton.setAttribute('title', 'Copy into clipboard');
        copyButton.append(icon);

        this.element.querySelector('.form-widget input').after(copyButton);
        copyButton.addEventListener('click', e => {this.copy()});
    }

    async copy() {
        let copyString = (this.element.dataset.stringPrefix || '')
            + (this.element.querySelector('.form-widget input').value || '')
            + (this.element.dataset.stringSuffix || '');

        try {
            await window.navigator.clipboard.writeText(copyString);
            console.log('Copied to clipboard');
        } catch (err) {
            console.error('Failed to copy: ', err);
        }
    }
}
