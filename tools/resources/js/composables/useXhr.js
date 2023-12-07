import { ref, watchEffect } from 'vue'
import NProgress from 'nprogress'

export default function useXhr(url, method = 'get', body = null) {
    var data = ref(null)
    var error = ref(null)
    var isSuccess = ref(false)

    const post = (url) => {
      if (method === 'post') {
        NProgress.start()
        axios
          .post(url.value, body)
          .then(response => {
            data.value = response.data
            if (response.data.error) {
              error.value = response.data.error
              isSuccess.value = false
            }
            else {
              isSuccess.value = true
              error.value = null
            }
          })
          .catch((err) => {
            isSuccess.value = false
            error.value = 'Sorry, we were unable to complete your request. Please refresh the page and try again.'
          })
          .finally(() => {
            NProgress.done()
          })
      }
    }

    watchEffect(() => {
      if (method === 'post' && url.value?.length > 0) {
        post(url)
      } else {
        error.value = null
        isSuccess.value = null
      }
    })

    return { data, error, isSuccess }
}
