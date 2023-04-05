import Api from './Api'
import UrlHelper from '@/helpers/UrlHelper'

export default {
  async getAll(params) {
    params = params || {}
    const queryString = UrlHelper.stringify(params)
    let url = 'http://localhost:5000/api/authors'
    if (queryString) {
      url = `${url}?${queryString}`
    }
    const res = await Api.get(url)
    return res.data
  },
}