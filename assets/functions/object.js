import { parseNameAttribute } from "./string"

/**
 * 
 * @param {FormData} formData 
 * @returns {Object}
 */
export function getFormData(formData)
{
  const formDataObject = {}

  for (const [name, value] of formData) {
    const {key, index, subKey} = parseNameAttribute(name)
    
    if (subKey === undefined) {
      formDataObject[key] = value
      continue
    } 
    
    if (Array.isArray(formDataObject[key])) {
      formDataObject[key][index] = {...formDataObject[key][index], [subKey]: value}
    } else {
      formDataObject[key] = [{[subKey]: value}]
    }
  }

  return formDataObject
}