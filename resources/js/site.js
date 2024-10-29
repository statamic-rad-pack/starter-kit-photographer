import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import Masonry from 'alpinejs-masonry'
import Images from '@aerni/alpine-statamic-responsive-images'
import Precognition from 'laravel-precognition-alpine';
import form from './alpine/form.js'

Alpine.data('form', form)
Alpine.plugin([Masonry, Images, Precognition])
Livewire.start()
