import axios from 'axios'

// TODO:
const host = 'localhost'

function headers() {
  const token = ''
  const authHeader = token
    ? { Authorization: 'Bearer ' + token }
    : {};
  return {
    headers: {
      ...authHeader,
      'Content-Type': 'application/json'
    }
  };
}

export default {
  get(url, queryParams) {
    queryParams = queryParams || {}
    const response = axios.get(`${url}`, {
      params: queryParams,
      ...headers()
    })
    return response
  },
  post() {},
  patch() {}
}