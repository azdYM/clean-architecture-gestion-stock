import { parseInputName } from "./string"


// exemple :

// input:
// 0: name → "Abdoul-wahid Hassani"
// 1: nickname → ""
// 2: gender → "F"
// 3: "locations[0][city]" → "Tsidjé"
// 4: "locations[0][region]" → "Itsandra"
// 5: "locations[0][neighborhood]" → "hananika"
// 6: "locations[1][city]" → "Moroni"
// 7: "locations[1][region]" → "Mboudé"
// 8: "locations[1][neighborhood]" → "Sans fil"
// 9: "contacts[0][telephone]" → "2344323"
// 10: "contacts[0][email]" → "yo@gmail.com"
// 11: "contacts[1][telephone]" → "4323456"
// 12: "contacts[1][email]" → "aza@gmail.com"

// output
// {
//   name: "Abdoul-wahid Hassani",
//   nickname: 'azad'
//   gender: 'F
//   locations: [
//     1: {city: '...', region: '...', neighborhood: '...'},
//     2: {city: '...', region: '...', neighborhood: '...'},
//   ] 
//   contacts: [
//     1: {email: '...', telephone: '...'},
//     2: {email: '...', telephone: '...'},
//   ]
// }

/**
 * Convertit un objet FormData en un objet JavaScript structuré en fonction de la convention de nommage des champs.
 * @param {FormData} formData - L'objet FormData à convertir.
 * @returns {Object} - L'objet JavaScript structuré.
 */
export function formDataToStructuredObject(formData: FormData): Record<string, any> {
  // Initialise un objet pour contenir les données structurées.
  const structuredObject: Record<string, any> = {}

  // Parcourt les données du formulaire.
  for (const [name, value] of formData) {
    // Utilise la fonction parseInputName pour extraire des informations à partir du nom du champ.
    const parserAttribute = parseInputName(name)

    // Si le nom du champ n'est pas valide, renvoie un objet vide.
    if (parserAttribute === null) {
      return {}
    }

    // Extrait les informations de la fonction parseInputName.
    const { key, index, subKey } = parserAttribute

    // Si la clé existe déjà dans l'objet structuré.
    if (key in structuredObject) {
      if (index !== undefined) {
        // Crée un tableau s'il n'existe pas encore.
        if (!Array.isArray(structuredObject[key])) {
          structuredObject[key] = []
        }

        if (subKey) {
          // Crée un objet s'il n'existe pas encore.
          if (!structuredObject[key][index]) {
            structuredObject[key][index] = {}
          }

          // Attribue la valeur à la sous-clé.
          structuredObject[key][index][subKey] = convertValue(value)
        } else {
          // Attribue la valeur à l'index dans le tableau.
          structuredObject[key][index] = convertValue(value)
        }
      } else {
        // Gérez ici la logique pour le cas où "key" existe mais "index" est indéfini.
      }
    } else {
      if (index !== undefined) {
        // Crée un tableau s'il n'existe pas encore.
        structuredObject[key] = []

        if (subKey) {
          // Crée un objet s'il n'existe pas encore.
          structuredObject[key][index] = {}
          // Attribue la valeur à la sous-clé.
          structuredObject[key][index][subKey] = convertValue(value)
        } else {
          // Attribue la valeur à l'index dans le tableau.
          structuredObject[key][index] = convertValue(value)
        }
      } else {
        if (subKey) {
          // Crée un objet s'il n'existe pas encore.
          structuredObject[key] = {}
          // Attribue la valeur à la sous-clé.
          structuredObject[key][subKey] = convertValue(value)
        } else {
          // Attribue la valeur directement.
          structuredObject[key] = convertValue(value)
        }
      }
    }
  }

  // Retourne l'objet structuré final.
  return structuredObject
}

const convertValue = function(value: any) {
  let typedValue: any = value

  if (typeof value === 'string') {
    const numberValue = parseFloat(value)
    if (!isNaN(numberValue)) {
      typedValue = numberValue
    }
  }

  return typedValue
}

export const isEmptyObject = function(obj: Object) {
  return Object.keys(obj).length === 0;
}