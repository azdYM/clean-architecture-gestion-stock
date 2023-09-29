import { useState } from "react"


export const TextInput = ({onChange = null, errors = [], ...props}) =>
{  
  return (
    <div className='gck-text-input'>
      <Input {...props} onChange={onChange} />
      <ShowErrors errors={errors}/>
    </div>
  )
}

function Input({onChange = null, ...props})
{
  const {label, className = '', ...attrs} = props
  const handleChange = (e) => {
    if (onChange !== null) onChange(e)
  }
  
  return(
    <div className={`gck-input ${className}`} >
      <label>{label}</label>
      <input 
        {...attrs}
        placeholder={label}
        onInput={handleChange} 
        
      />
    </div>
  )
}

export const SelectInput = ({options, label, name, defaultValue = null, errors = []}) =>
{
  return (
    <div className='gck-select-input'>
      <Select options={options} label={label} name={name} defaultValue={defaultValue} />
      <ShowErrors errors={errors}/>
    </div>
  );
}

function Select({options, name, label, defaultValue})
{
  const [selectedOption, setSelectedOption] = useState(defaultValue)

  const handleSelectChange = (e) => {
    setSelectedOption(e.currentTarget.value)
  }

  const handleSelectFocus = (e) => {
    setSelectedOption(e.currentTarget.value)
  }

  const handleSelectBlur = (e) => {
    setSelectedOption(e.currentTarget.value)
  }

  return (
    <div className='gck-input'>
        <label htmlFor={name}>{label}</label>
        <select
          name={name}
          value={selectedOption}
          onChange={handleSelectChange}
          onFocus={handleSelectFocus}
          onBlur={handleSelectBlur}
        >
          <option value="" disabled>{label || 'Sélectionnez une option'}</option>
          {options.map((option, index) => (
            <option key={index} value={option.value}>
              {option.label}
            </option>
          ))}
        </select>
    </div>
  )
}

function ShowErrors({errors})
{
  return (
    <ul className='errors'>
      {errors.map(error => <li>{error}</li>)}
    </ul>
  )
}

export const SubmitFormButton = ({}) =>
{
  return (
    <button type='submit' className='gck-button-submit'>Sauvegarder</button>
  )
}


