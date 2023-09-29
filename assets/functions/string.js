/**
 * 
 * @param {string} fullname 
 */
export function getAcronyme(fullname)
{
    const [first, second] = fullname.split(' ')
    return first[0].toLocaleUpperCase() + second[0].toLocaleUpperCase()
}

/**
 * 
 * @param {string} string
 * @param {int} length 
 */
export function substring(string, length)
{
    return string.length < length ? string : string.substring(0, length) + '...'
}

/**
 * 
 * @param {string} string 
 * @returns string
 */
export function capitalize(string)
{
    return string[0].toLocaleUpperCase() + string.substring(1)
}

/**
 * parse l'attribut name de input et récupere defférents parties, séparément 
 * Exp : contacts[1][email] => contacts, 1, email
 * 
 * @param {string} name 
 */
export function parseNameAttribute(name) 
{
  const regex = /(\w+)(?:\[(\d+)\])?(?:\[(\w+)\])?/g
  const [, key, index, subKey] = regex.exec(name)
  return {key, index, subKey}
}

export function isEmpty(value)
{
    if (Array.isArray(value)) {
        return value.length === 0
    }
    
    return value === '' || value === null || value === undefined
}