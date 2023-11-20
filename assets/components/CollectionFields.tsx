import { useState } from "react";
import { TextInput } from "./Fields";
import { capitalize, isEmpty, parseInputName } from "../functions/string";
import { checkEntriesValueIsEmpty, lastInArray } from "../functions/array";
import { isEmptyObject } from "../functions/object";

type CustomCollectionFields = {
	collectionKey: string,
	formFieldModels: Array<object|number|string>,
	customData: {[key: string]: any},
	textAddButton: string
}

export type EntrieValues = {
	defaultValue: any,
	label: string|null,
	id?: number,
	type?: any,
	min?: number,
	max?: number,
	disabled?: boolean,
	hidden?: boolean,
	onChange?: ((e: React.FormEvent) => void)|null
}


type FieldsRowsProps = {
	collectionKey: string, 
	defaulCollectionData: Array<{[key: string]: any}>, 
	onDeleteRow?: (row: number) => void,
}

type FieldsRowProps = {
	defaultKey: string, 
	fieldIndex: number, 
	defaultFields: {[key: string]: any}, 
	onDeleteRow?: (row: number) => void
}

type FieldProps = {
	index: number;
	collectionName: string;
	onUpdateEntrie: (e: React.FormEvent) => void;
	entrie: [string, EntrieValues] 
}

export const CustomCollectionFields = ({collectionKey, formFieldModels, customData, textAddButton}: CustomCollectionFields) => {
	const defaultData = formFieldModels.map(
		model => generateDefaultData(model, customData, true)
	)

	if (isEmpty(defaultData)) {
		defaultData.push(generateDefaultData({}, customData))
	}
	
	const [collection, setCollection] = useState(defaultData)
	
	const handleAddRow = (e: React.FormEvent) => {
		e.preventDefault()
		setCollection(() => 
			[...collection, generateDefaultData(lastInArray(collection), customData)]
		)
	}

	const handleDeleteRow = function(rowToDelete: number) {
		setCollection((currentCollection) => currentCollection.filter(row => row.id !== rowToDelete))
	}

	return (
		<div className='gck-collection-fields mb3'>
			<FieldsRowsRenderer 
				collectionKey={collectionKey} 
				defaulCollectionData={collection} 
				onDeleteRow={handleDeleteRow} 
			/>
			<button onClick={handleAddRow} className='btn-add'>{textAddButton}</button>
		</div>
	)
}

const FieldsRowsRenderer = function({collectionKey, defaulCollectionData, onDeleteRow}: FieldsRowsProps) 
{
	return (
		<>
		{defaulCollectionData.map((field, index) => 
			<FieldsRowRenderer key={index} fieldIndex={index} defaultKey={collectionKey} 
				defaultFields={field} onDeleteRow={onDeleteRow} 
			/>
		)}
		</>
	)
}

const FieldsRowRenderer = function({defaultKey, fieldIndex, defaultFields, onDeleteRow}: FieldsRowProps)
{
	// const {id, ...usedDefaultFields} = defaultFields
	const [field, setField] = useState(defaultFields) 
	const entries = Object.entries(field)
	const isEmpty = checkEntriesValueIsEmpty(entries)

	const handleChange = (e: React.FormEvent) => {
		const input = e.currentTarget as HTMLInputElement
		const name = input.name
		const value = input.value 

		const nameParsed = parseInputName(name) // [contacts][1][label]
		if (nameParsed === null) return

		setField((curr) => {
			const itemAttributes = curr[nameParsed.subKey]
			if (typeof itemAttributes === 'object') {
				return {...curr, [nameParsed.subKey]: {...itemAttributes, defaultValue: value}}
			}

			return {...curr, [nameParsed.subKey]: value}
		})
	}
	
	const handleDelete = (e: React.FormEvent) => {
		e.preventDefault()
		onDeleteRow !== undefined && onDeleteRow(defaultFields.id)
	}
	
	return(
		<div className={`${isEmpty ? 'gck-entries-empty' : ''} mb2`}>
			<div className="gck-input-groups">
				{entries.map((entrie, index) => 
					<FieldRenderer 
						key={index} 
						entrie={entrie} 
						index={fieldIndex} 
						collectionName={defaultKey} 
						onUpdateEntrie={handleChange} 
					/>
				)}
			</div>
			{isEmpty && fieldIndex > 0 && <button onClick={handleDelete} className='btn-delete'>Supprimer</button>}
		</div>
	)
}

const FieldRenderer = function({index, collectionName, entrie, onUpdateEntrie}: FieldProps)
{
	const [key, value] = entrie
	const name = `${collectionName.toLocaleLowerCase()}[${index}][${key}]`
	const {defaultValue, label, disabled, hidden, onChange, ...props} = value
	const handleChange = (e: React.FormEvent) => {
		const input = e.currentTarget as HTMLInputElement
		
		if (props.type === 'number' && isNaN(parseInt(input.value, 10))) {
			input.value = ''
			onUpdateEntrie(e)
			return false
		}

		onUpdateEntrie(e)
		typeof onChange === 'function' && onChange(e)
	}
	
	return(
		<>
			{hidden 
				? <input name={name} hidden defaultValue={defaultValue} />
				: (
					<TextInput 
						onChange={handleChange} 
						placeholder={capitalize(label ?? key)} 
						defaultValue={defaultValue} 
						name={name} 
						hidden={hidden ? true : false}
						disabled={disabled ? true : false}
						errors={[]} 
					/>
				)
			}
		</>
	)
}

const generateDefaultData = function(model: {[key: string]: any}|string|number, customData: {[key: string]: any}, useDefaultData?: boolean) 
{
	let data: {[key: string]: any} = {}

	if (isEmptyObject(model)) {
		for (const [key, value] of Object.entries(customData)) {
			if (key === 'id') {
				data[key] = {...value, defaultValue: 1}
			}
			else {
				data[key] = {...value}
			}
		} 
	}

	else {
		for (const [key] of Object.entries(customData)) {
			if (key === 'id') {
				//Je recupère la valeur de la clé id
				let value = getKeyValueFromModel(key, model)

				// s'il s'agit d'un objet, je recuper la valeur exacte contenu dans la propriété defaultValue
				if (typeof value === 'object') {
					value = value.defaultValue
				}

				// Je remet toutes les propriété de la clé id
				// Si je veux utiliser les valeur par défaut (c'est a dire que modele possede des vraies données, c'est peut être une modification)
				// je garde cette valeur, sinon je prend la valeur et je le rajoute plus un parce qu'il s'agit 
				// de la denrière ligne de la collection et qu l'identifiant existe déjà
				data.id = {...customData['id'], defaultValue: useDefaultData ? value : Number(value) + 1}
				// puisque je ne veux pas écraser la clé id, je passe a la prochaine clé (itération)
				continue
			} 

			// je rajoute les clés qui reste
			data[key] = {defaultValue: useDefaultData ? getKeyValueFromModel(key, model) : null, ...customData[key] ?? ''}
		} 
	}
	
	return data
}

const getKeyValueFromModel = function(key: string, value: string|number|{[key: string]: any}) {
	if (typeof value === 'object') {
		return value[key]
	}

	return value
}

