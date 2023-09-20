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