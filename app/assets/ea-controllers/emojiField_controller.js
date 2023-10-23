import { Controller } from '@hotwired/stimulus';

import { Picker } from 'emoji-picker-element';
import insertTextAtCursor from 'insert-text-at-cursor';
import { createPopper } from '@popperjs/core';

export default class extends Controller {
    connect() {
        this.element.querySelector('.form-widget input').style.display = 'inline-block';
        this.element.querySelector('.form-widget input').style.width = 'calc(100% - 3em)';

        const emojiPicker = new Picker();
        emojiPicker.classList.add('emoji-picker');
        emojiPicker.style.display = 'none';
        emojiPicker.style.zIndex  = '1000';
        emojiPicker.addEventListener('emoji-click', e => {
            insertTextAtCursor(this.element.querySelector('input'), e.detail.unicode)
        });

        const popButton = document.createElement('div');
        popButton.classList.add('btn', 'btn-secondary', 'float-end');
        popButton.append('🙂');

        this.element.querySelector('.form-widget').append(popButton);
        this.element.querySelector('.form-widget').append(emojiPicker);

        createPopper(popButton, emojiPicker, {
            placement: 'bottom-end',
        });

        popButton.addEventListener('click', e => {
            emojiPicker.classList.toggle('d-block');
        });
    }
}
