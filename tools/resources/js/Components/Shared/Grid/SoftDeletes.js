import NProgress from 'nprogress';
import { router } from '@inertiajs/vue3'

export default function SoftDeletes(emit) {
    const flash = (keyIn, value) => {
        emit('updateFlash', [keyIn, value])
    }

    const remove = (url, entityName, messageAppendText='') => {
        if (confirm('Are you sure you want to remove ' + entityName + '? ' + messageAppendText)) {
            NProgress.start()

            axios
                .delete(url)
                .then(response => {
                    if(response.data.flash?.error) {
                        flash('error', response.data.flash.error)
                    }
                    if(response.data.flash?.warning) {
                        flash('warning', response.data.flash.warning)
                    }
                    if(response.data.flash?.message) {
                        flash('message', response.data.flash.message)
                    }
                    if(response.data.flash?.success) {
                        flash('success', response.data.flash.success + ' (' + entityName + ')')
                        router.reload()
                    }
                })
                .catch((err) => {
                    flash('error', 'Sorry, we could not remove ' + entityName + '. Please reload the page and try again.')
                })
                .finally(() => {
                    NProgress.done()
                })
        }
    }

    const restore = (url, entityName) => {
        NProgress.start()

        axios
            .get(url)
            .then(response => {
                if(response.data.flash?.error) {
                    flash('error', response.data.flash.error)
                }
                if(response.data.flash?.success) {
                    flash('success', response.data.flash.success + ' (' + entityName + ')')
                    router.reload()
                }
            })
            .catch((err) => {
                flash('error', 'Sorry, we could not restore ' + entityName + '.  Please reload the page and try again.')
            })
            .finally(() => {
                NProgress.done()
            })

    }

    return {remove, restore}
}