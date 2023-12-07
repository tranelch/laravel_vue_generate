export default function useQuerystring() {
  const objectToQueryString = (initialObj) => {
    const reducer = (obj, parentPrefix = null) => (prev, key) => {
      const val = obj[key];
      key = encodeURIComponent(key);
      const prefix = parentPrefix ? `${parentPrefix}[${key}]` : key;

      if (val == null || typeof val === 'function') {
        prev.push(`${prefix}=`);
        return prev;
      }

      if (['number', 'boolean', 'string'].includes(typeof val)) {
        prev.push(`${prefix}=${encodeURIComponent(val)}`);
        return prev;
      }

      prev.push(Object.keys(val).reduce(reducer(val, prefix), []).join('&'));
      return prev;
    };

    return Object.keys(initialObj).reduce(reducer(initialObj), []).join('&');
  };


  const getQueryString = (filterObject, sortQueryString) => {
    return {...getFilterQueryString(filterObject), ...sortQueryString}
  }

  const getFilterQueryString = (filterObject) => {
      let query = Object.fromEntries(Object.entries(filterObject).filter(([_, v]) => (v != null && v != 'null' && (v > 0 || v.length > 0 || (Object.keys(v).length > 0)))))
      return Object.keys(query).length ? query : ''
  }

  return {objectToQueryString, getQueryString, getFilterQueryString, }
}