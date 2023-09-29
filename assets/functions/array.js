import { isEmpty } from "./string"

/**
 * 
 * @param {array} array 
 * @returns {number}
 */
export const lastInArray = (array) =>
{
    return array[array.length - 1]
}

/**
 * 
 * @param {array} entries 
 */
export const checkEntriesValueIsEmpty = (entries) =>
{
    for (const [, value] of entries) {
        const checkedValue = typeof value === 'object' ? value['defaultValue'] : value
        
        if (!isEmpty(checkedValue)) {
            return false
        }
    }

    return true
}



