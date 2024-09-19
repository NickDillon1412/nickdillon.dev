import './bootstrap';

import {
    Livewire,
    Alpine
} from '../../vendor/livewire/livewire/dist/livewire.esm';
import Typewriter from '@marcreichel/alpine-typewriter';
import '../../vendor/masmerise/livewire-toaster/resources/js';

Alpine.plugin(Typewriter);

Livewire.start();
