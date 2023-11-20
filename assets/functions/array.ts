import { isEmpty } from "./string"

export type EntriesUnknownType = {
    [key: string]: unknown
}

export const lastInArray = <T>(array: Array<T>) =>
{
    return array[array.length - 1]
}

export const checkEntriesValueIsEmpty = <T extends (number|string|{[key: string]: unknown})>(entries: [string, T][]) =>
{
    for (const [key, value] of entries) {

        if (key === 'id') continue // Le champ id n'est pas pris en compte, on s'en fout s'il est vide ou pas
        if (value === null) continue
        const checkedValue = typeof value === 'object' ? value['defaultValue'] : value
        
        if (!isEmpty(checkedValue)) {
            return false
        }
    }

    return true
}



