
export function getAcronyme(fullname: string)
{
	const [first, second] = fullname.split(' ')
	return first[0].toLocaleUpperCase() + second[0].toLocaleUpperCase()
}

export function substring(string: string, length: number)
{
  return string.length < length ? string : string.substring(0, length) + '...'
}

export function capitalize(string: string)
{
  return string[0].toLocaleUpperCase() + string.substring(1)
}

/**
 * parse l'attribut name de input et récupere les différentes parties séparément 
 * Exp : contacts[1][email] => contacts, 1, email
 */
export function parseInputName(name: string) 
{
  const regex = /(\w+)(?:\[(\d+)\])?(?:\[(\w+)\])?/g
	const regexExec = regex.exec(name)

	if (regexExec === null) {
		return null
	}
	
	const [, key, index, subKey] = regexExec
	return {key, index, subKey}
}

export function isEmpty(value: any)
{
	if (Array.isArray(value)) {
		return value.length === 0
	}
	
	return value === '' || value === null || value === undefined
}