import './bootstrap';

import {
    Livewire,
    Alpine
} from '../../vendor/livewire/livewire/dist/livewire.esm';
import Typewriter from '@marcreichel/alpine-typewriter';
import anchor from '@alpinejs/anchor';
import collapse from '@alpinejs/collapse';
import '../../vendor/masmerise/livewire-toaster/resources/js';

Alpine.plugin(Typewriter, anchor, collapse);

Livewire.start();
