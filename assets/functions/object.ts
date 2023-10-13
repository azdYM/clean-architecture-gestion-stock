import { parseInputName } from "./string"

type TransformedFormData = {
  [key: string|number]: any 
}

export function formDataToStructuredObject(formData: FormData): Record<string, any>
{
  const structuredObject: Record<string, any> = {}

  for (const [name, value] of formData) 
  {
    const parserAttribute = parseInputName(name)
    if (parserAttribute === null) {
      return {}
    }

    const {key, index, subKey} = parserAttribute

    // {
    //   nom: "azad",
    //   birdDay: {city: '', }   
    //   contacts: [
    //     1: {email: '', telephone: ''},
    //     2: {email: ''},
    //   ]
    // }

    if (key in structuredObject) {
      if (index !== undefined) {
        if (!Array.isArray(structuredObject[key])) {
          structuredObject[key] = []
        }

        if (subKey) {
          if (!structuredObject[key][index]) {
            structuredObject[key][index][subKey] = {}
          }

          structuredObject[key][index][subKey] = value
        }

        else {
          structuredObject[key][index] = value
        }
      }

      else {

      }
      
    }

    else {

    }

    // // Si le subkey n'est pas définit. on a un valeur primitif donc on passe au suivant
    // if (subKey === undefined) {
    //   structuredObject[key] = value
    //   continue
    // } 
    
    // if (Array.isArray(structuredObject[key])) {
    //   structuredObject[key][index] = {...structuredObject[key][index], [subKey]: value}
    // } else {
    //   structuredObject[key] = [{[subKey]: value}]
    // }
  }

  return structuredObject
}

export const isEmptyObject = function(obj: Object) {
  return Object.keys(obj).length === 0;
}