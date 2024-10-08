import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import Masonry from 'alpinejs-masonry'
import Stack from './stack'
import Images from '@aerni/alpine-statamic-responsive-images'
import Precognition from 'laravel-precognition-alpine';
import form from './alpine/form.js'

Alpine.data('form', form)
Alpine.plugin([Masonry, Stack, Images, Precognition])
Livewire.start()
