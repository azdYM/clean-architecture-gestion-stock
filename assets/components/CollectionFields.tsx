import { useState } from "react";
import { TextInput } from "./Fields";
import { capitalize, isEmpty, parseInputName } from "../functions/string";
import { checkEntriesValueIsEmpty, lastInArray } from "../functions/array";
import { isEmptyObject } from "../functions/object";

type CustomCollectionFieldsType = {
	collectionKey: string,
	formFieldModels: [],
	customData: {[key: string]: any},
	textAddButton: string
}

export type EntrieValuesType = {
	defaultValue: any,
	label: string|null,
	id?: number,
	type?: any,
	min?: number,
	max?: number,
	disable?: boolean,
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
	entrie: [string, EntrieValuesType] 
}

export const CustomCollectionFields = ({collectionKey, formFieldModels, customData, textAddButton}: CustomCollectionFieldsType) => {
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
	console.log(collection, "handle delete row")

	return (
		<div className='gck-collection-fields mb3'>
			<FieldsRowsRenderer collectionKey={collectionKey} defaulCollectionData={collection} onDeleteRow={handleDeleteRow} />
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
	const {id, ...usedDefaultFields} = defaultFields; // 
	const [field, setField] = useState(usedDefaultFields) 
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
		onDeleteRow !== undefined && onDeleteRow(id)
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
	const {defaultValue, label, onChange, ...props} = value
	
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
		<TextInput 
			onChange={handleChange} 
			placeholder={capitalize(label ?? key)} 
			defaultValue={defaultValue} 
			name={name} 
			errors={[]} 
		/>
	)
}

const generateDefaultData = function(model: {}, customData: {[key: string]: any}, useDefaultData?: boolean) 
{
	let data: {[key: string]: any} = {}
	console.log('render')
	if (isEmptyObject(model)) {
		for (const [key, value] of Object.entries(customData)) {
			data[key] = {...value}
		} 

		data.id = 1
	}

	else {
		for (const [key, defaultValue] of Object.entries(model)) {
			if (key === 'id') {
				data.id = Number(defaultValue) + 1
				continue
			} 
			
			data[key] = {defaultValue: useDefaultData === true ? defaultValue : null, ...customData[key] ?? ''}
		} 
	}
	
	return data
}

