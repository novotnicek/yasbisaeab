import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        let dependsOn = document.getElementById(this.element.dataset.dependson);
        let dependsValue = this.element.dataset.dependsvalue;
        let dependentElement = this.element.closest('.form-group');

        if (this.element.dataset.queryselector != undefined) {
            dependentElement = this.element.closest(this.element.dataset.queryselector);
        }

        dependentElement.classList.add('d-none');

        if (dependsOn.getAttribute('type') === 'checkbox') {
            if (dependsOn.checked == dependsValue) {
                dependentElement.classList.remove('d-none');
            }

            dependsOn.addEventListener('change', (event) => {
                if (event.target.checked == dependsValue) {
                    dependentElement.classList.remove('d-none');
                } else {
                    dependentElement.classList.add('d-none');
                }
            });
        }

        // TODO: add support for choiceType
    }
}
