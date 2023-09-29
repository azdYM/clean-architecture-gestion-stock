import { SelectInput, TextInput } from "./Fields"
import { useCustomContext } from "/functions/hooks"
import { ClientContext } from "/functions/context"
import { CustomCollectionFields } from "./CustomFields"

export const IndividualGeneralInformation = ({defaultData, errors}) =>
{
  const {folio, name, nickName, gender} = defaultData
  const genderOptions = [{label: 'Homme', value: 'H'}, {label: 'Femme', value: 'F'}]

  return (
    <div className='mb5'>
      <div className='gck-input-groups'>
        <TextInput disabled defaultValue={folio} label="Folio" name='folio' errors={errors}/>
        <TextInput defaultValue={name} label="Nom complet" name='name' errors={errors}/>
        <TextInput defaultValue={nickName} label="Surnom" name='nickname' errors={errors}/>
        <SelectInput options={genderOptions} defaultValue={gender} name='gender' label='Genre' />
      </div>
    </div>
  )
}

export const CorporateGeneralInformation = ({defaultData, errors}) =>
{
  const {name, nickName, gender, nin} = defaultData
  const genderOptions = [{label: 'Homme', value: 'H'}, {label: 'Femme', value: 'F'}]

  return (
    <div className='mb5'>
      <div className='gck-input-groups'>
        <TextInput defaultValue={name} label="Nom complet" name='name' errors={errors}/>
        <TextInput defaultValue={nickName} label="Surnom" name='nickname' errors={errors}/>
        <SelectInput options={genderOptions} defaultValue={gender} name='gender' label='Genre' />
        <TextInput defaultValue={nin} name='nin' label='NIN' />
      </div>
    </div>
  )
}

export const MoreInformationAboutAnotherProperties = ({title, fields, textButton, errors}) =>
{
  const {client: {[title]: models}} = useCustomContext(ClientContext)

  return (
    <CustomCollectionFields 
      collectionKey={title} 
      textAddButton={textButton} 
      customData={fields} 
      formFieldModels={models}
    />
  )
}



