import './bootstrap';

import {
    Livewire,
    Alpine
} from '../../vendor/livewire/livewire/dist/livewire.esm';

import Typewriter from '@marcreichel/alpine-typewriter';
import anchor from '@alpinejs/anchor';
import collapse from '@alpinejs/collapse';
import flatpickr from "flatpickr";

window.flatpickr = flatpickr;

Alpine.plugin(Typewriter, anchor, collapse);

Livewire.start();
