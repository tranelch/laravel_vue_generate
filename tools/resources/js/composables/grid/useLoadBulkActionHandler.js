import { computed } from "vue"
import { router } from '@inertiajs/vue3'
import NProgress from 'nprogress'

export default function useLoadBulkActionHandler (path) {
  // Returns an asynchronous promise of a flash message array
  const handle = (postParams, actionPath) => {
    NProgress.start()
    return axios
      .put(path + actionPath, postParams)
      .then(response => {
        router.reload({ only: ['loads'] })
        if (response.data.error) {
          return ['error', response.data.error]
        }
        var loadText = ''
        if (response.data.load_ids && response.data.load_ids.length > 0) {
          loadText = ' (Loads: ' + response.data.load_ids.join(', ') + ')'
        }
        if (response.data.load_ids && response.data.load_ids.length == 0) {
          return ['message', 'None of the submitted loads were eligible.']
        }
        return ['success', 'Eligible loads were processed successfully' + loadText + '.']
      })
      .catch((err) => {
        return ['error', 'Sorry, we could not process the loads.  Please reload the page and try again.']
      })
      .finally(() => {
        NProgress.done()
      })
  }

  return { handle }
}

