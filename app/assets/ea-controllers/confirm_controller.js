import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    showConfirmBox() {
        document.getElementById('overlay').hidden = false;
        document.getElementById('confirmationQuestion').innerText = this.element.dataset.question;
        document.getElementById('confirmationSubmit').dataset.href = this.element.dataset.href;
    }

    closeConfirmBox() {
        document.getElementById('overlay').hidden = true;
    }

    isConfirm() {
        if (this.element.dataset.href) {
            // console.log(this.element.dataset.href);

            // if startWith('#'), click element with this ID (eg. submit button)
            if (this.element.dataset.href.startsWith('#')) {
                document.getElementById(this.element.dataset.href.substring(1)).click();
            } else {
                window.location = this.element.dataset.href;
            }
        }

        this.closeConfirmBox();
    }
}
