import './bootstrap';

import {
    Livewire,
    Alpine
} from '../../vendor/livewire/livewire/dist/livewire.esm';

import Typewriter from '@marcreichel/alpine-typewriter';
import anchor from '@alpinejs/anchor';
import collapse from '@alpinejs/collapse';
import flatpickr from "flatpickr";
import '../../vendor/spatie/livewire-filepond/resources/dist/filepond.css';
import '../../vendor/spatie/livewire-filepond/resources/dist/filepond';

window.flatpickr = flatpickr;

Alpine.plugin(Typewriter, anchor, collapse);

Livewire.start();
