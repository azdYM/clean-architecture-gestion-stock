import { useState } from "react"

type TextInputProps = {
  onChange?: (e: React.FormEvent<HTMLInputElement>) => void; // Utilisez React.ChangeEvent pour gérer les événements d'input
  errors?: string[]; // Une liste de chaînes d'erreurs
} & React.InputHTMLAttributes<HTMLInputElement>; // Inclure les autres attributs d'un champ d'entrée HTML


type InputProps = {
  onChange?: (e: React.FormEvent<HTMLInputElement>) => void,
} & React.InputHTMLAttributes<HTMLInputElement>

export type Option = {
  label: string;
  value: string|number;
};

type SelectProps = {
  options: Option[];
  name: string;
  label: string;
  defaultValue: string | null;
  onChange?: (value: string) => void;
  onFocus?: (value: string) => void;
  onBlur?: (value: string) => void;
};

type SelectInputProps = {
  options: Option[];
  label: string;
  name: string;
  defaultValue: string | null;
  errors?: string[];
  onChange?: (value: string) => void;
  onFocus?: (value: string) => void;
  onBlur?: (value: string) => void;
};

export const TextInput: React.FC<TextInputProps> = ({onChange, errors = [], ...props}) =>
{  
  return (
    <div className='gck-text-input'>
      <Input {...props} onInput={onChange} />
      <ShowErrors errors={errors}/>
    </div>
  )
}

const Input = function({onChange, ...props}: InputProps)
{
  const {placeholder, className = '', ...attrs} = props

  return(
    <div className={`gck-input ${className}`} >
      <label>{placeholder}</label>
      <input 
        {...attrs}
        placeholder={placeholder}
      />
    </div>
  )
}

export const SelectInput: React.FC<SelectInputProps> = ({ options, label, name, defaultValue, errors, onChange, onFocus, onBlur }) => {
  return (
    <div className="gck-select-input">
      <Select options={options} label={label} name={name} defaultValue={defaultValue} onChange={onChange} onFocus={onFocus} onBlur={onBlur} />
      {errors !== undefined && <ShowErrors errors={errors}/>}
    </div>
  );
}

const Select: React.FC<SelectProps> = ({ options, name, label, defaultValue, onChange, onFocus, onBlur }) => {
  const [selectedOption, setSelectedOption] = useState<string | null >(defaultValue);

  const handleSelectChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
    const selectedValue = e.currentTarget.value;
    setSelectedOption(selectedValue);
    onChange !== undefined && onChange(selectedValue);
  };

  const handleSelectFocus = () => {
    if (selectedOption !== null) {
      onFocus !== undefined && onFocus(selectedOption);
    }
  };

  const handleSelectBlur = () => {
    if (selectedOption !== null) {
      onBlur !== undefined && onBlur(selectedOption);
    }
  };

  return (
    <div className="gck-input">
      <label htmlFor={name}>{label}</label>
      <select
        name={name}
        value={selectedOption || ""}
        onChange={handleSelectChange}
        onFocus={handleSelectFocus}
        onBlur={handleSelectBlur}
      >
        <option value="" disabled>
          {label || "Sélectionnez une option"}
        </option>
        {options.map((option, index) => (
          <option key={index} value={option.value}>
            {option.label}
          </option>
        ))}
      </select>
    </div>
  );
}

const ShowErrors = function({errors}: {errors: string[]})
{
  return (
    <ul className='errors'>
      {errors.map(error => <li>{error}</li>)}
    </ul>
  )
}

export const SubmitFormButton = function({text = 'Sauvegarder'}: {text?: string})
{
  return (
    <button type='submit' className='gck-button-submit'>{text}</button>
  )
}


