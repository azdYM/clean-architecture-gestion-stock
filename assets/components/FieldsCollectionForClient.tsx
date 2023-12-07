import { SelectInput, TextInput } from "./Fields"
import { useCustomContext } from "../functions/hooks"
import { CustomCollectionFields } from "./CollectionFields"
import { ClientContext, CorporateType, IndividualType } from "../functions/context"

export const IndividualGeneralInformation = ({defaultData, errors}: {defaultData: IndividualType, errors?: []}) =>
{
  const {folio, name, nickname, gender} = defaultData
  const genderChoices = [{label: 'Homme', value: 'H'}, {label: 'Femme', value: 'F'}]

  return (
    <div className='mb5'>
      <div className='gck-input-groups'>
        <TextInput disabled defaultValue={folio} placeholder="Folio" name='folio' errors={errors}/>
        <TextInput defaultValue={name} placeholder="Nom complet" name='name' errors={errors}/>
        <TextInput defaultValue={nickname} placeholder="Surnom" name='nickname' errors={errors}/>
        <SelectInput options={genderChoices} defaultValue={gender} name='gender' label='Genre' errors={errors ?? []} />
      </div>
    </div>
  )
}

export const CorporateGeneralInformation = ({defaultData, errors}: {defaultData: CorporateType, errors?: []}) =>
{
  const {name, folio, comericialRegistry} = defaultData

  return (
    <div className='mb5'>
      <div className='gck-input-groups'>
        <TextInput disabled defaultValue={folio} placeholder="Folio" name='folio' errors={errors}/>
        <TextInput defaultValue={name} placeholder="Nom de l'entreprise" name='name' errors={errors}/>
        <TextInput defaultValue={comericialRegistry} placeholder="Registre de commerce" name='comericialRegistry' errors={errors}/>
      </div>
    </div>
  )
}

type AnotherInformation = {
  title: ('contacts' | 'locations')
  fields: {[key: string]: any}
	onChange?: (e: React.MouseEvent) => void,
  textButton: string,
  errors?: []
}

export const AdditionalClientInfo = ({title, fields, textButton}: AnotherInformation) =>
{
  const client = useCustomContext(ClientContext)
  if (client === null) return
  return (
    <CustomCollectionFields 
      collectionKey={title} 
      textAddButton={textButton} 
      customData={fields} 
      formFieldModels={client[title] ?? []}
    />
  )
}



