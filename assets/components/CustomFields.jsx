import { useState } from "react";
import { checkEntriesValueIsEmpty, lastInArray } from "/functions/array";
import { capitalize, parseNameAttribute } from "/functions/string";
import { TextInput } from "./Fields";

export const CustomCollectionFields = ({collectionKey, formFieldModels = [], customData, textAddButton}) => {
	const defaultData = formFieldModels.map(
		model => generateDefaultData(model, customData)
	)
	
	const [collection, setCollection] = useState(defaultData)
	
	const handleAddItem = (e) => {
		e.preventDefault()
		setCollection(() => 
			[...collection, generateDefaultData(lastInArray(collection), customData, false)]
		)
	}

	const handleDeleteItem = (deleteItem) => {
		setCollection(() => collection.filter(item => item.id !== deleteItem.id))
	}

	return (
		<div className='gck-collection-fields mb3'>
			<CustomFormFields collectionKey={collectionKey} defaultData={collection} onDeleteItem={handleDeleteItem} />
			<button onClick={handleAddItem} className='btn-add'>{textAddButton}</button>
		</div>
	)
}

function CustomFormFields({collectionKey, defaultData = [], onDeleteItem}) 
{
	return (
		<>
			{defaultData.map((item, index) => 
				<FormFieldInput key={index} fieldIndex={index} defaultKey={collectionKey} 
					defaultItem={item} onDeleteItem={onDeleteItem} 
				/>
			)}
		</>
	)
}

function FormFieldInput({defaultKey, fieldIndex, defaultItem = {}, onDeleteItem})
{
	const {id, ...usedDefaultItem} = defaultItem; 
	const [item, setItem] = useState(usedDefaultItem) 
	const entries = Object.entries(item)
	const isEmpty = checkEntriesValueIsEmpty(entries)

	const handleChange = (e) => {
		const name = e.currentTarget.name
		const value = e.currentTarget.value 
		const {subKey} = parseNameAttribute(name)
		
		setItem(() => {
			if (typeof item[subKey] === 'object') {
				return {...item, [subKey]: {...item[subKey], defaultValue: value}}
			}

			return {...item, [subKey]: value}
		})
	}
	
	const handleDelete = (e) => {
		e.preventDefault()
		onDeleteItem(defaultItem)
	}
	
	return(
		<div className={`${isEmpty ? 'gck-entries-empty' : ''} mb2`}>
			<div className="gck-input-groups">
				{entries.map((entrie, index) => 
					<RenderEntrieElement 
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

function RenderEntrieElement({index, collectionName, onUpdateEntrie, entrie = []})
{
	const [key, value] = entrie
	const name = `${collectionName.toLocaleLowerCase()}[${index}][${key}]`
	const {defaultValue, label, onChange, ...props} = value
	
	const handleChange = (e) => {
		const value = e.currentTarget.value
		
		if (props.type === 'number' && isNaN(parseInt(value, 10))) {
			e.currentTarget.value = null
			onUpdateEntrie(e)
			return false
		}

		onUpdateEntrie(e)
		typeof onChange === 'function' && onChange(e)
	}
	
	return(
		<TextInput 
			{...props}
			onChange={handleChange} 
			label={capitalize(label ?? key)} 
			defaultValue={defaultValue} 
			name={name} 
			errors={[]} 
		/>
	)
}

function generateDefaultData(model, customData, useDefaultValue = true) 
{
	let data = {}

	for (const [key, defaultValue] of Object.entries(model)) {
		if (key === 'id') {
			data.id = defaultValue + 1
			continue
		} 

		data[key] = {defaultValue: useDefaultValue ? defaultValue : null, ...customData[key] ?? ''}
	} 
	
	return data
}
