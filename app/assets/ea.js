// EASY ADMIN javascripts and styles

// any CSS you import will output into a single css file (ea.css in this case)
import './styles/ea.css';

// jquery
const $ = require('jquery'); // this loads jquery, but does *not* set a global $ or jQuery variable
// global.$ = global.jQuery = $; // create global $ and jQuery variables

// trumbowyg
import 'trumbowyg';
import 'trumbowyg/dist/ui/sass/trumbowyg.scss';
import trumbowygSvgPath from 'trumbowyg/dist/ui/icons.svg';

$(document).ready(function() {
    $.trumbowyg.svgPath = trumbowygSvgPath;
    $('.trumbowygInit textarea').trumbowyg({
        btns: [
            ['viewHTML'],
            ['formatting'],
            ['strong', 'em'],
            ['link'],
            ['insertImage'],
            ['justifyLeft', 'justifyCenter', 'justifyRight'],
            ['unorderedList', 'orderedList'],
            ['horizontalRule'],
            ['removeformat'],
            ['fullscreen']
        ],
        // height: '400px', // waiting for https://github.com/Alex-D/Trumbowyg/pull/1418
    });
});

import { startStimulusApp } from '@symfony/stimulus-bridge';
// Registers Stimulus controllers from controllers.json and in the controllers/ directory
startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!./ea-controllers',
    true,
    /\.[jt]sx?$/
));
