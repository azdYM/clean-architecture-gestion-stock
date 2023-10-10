import { useRef } from "react"
import { Icon } from "./Icon"
import { ClientContext } from "/functions/context"
import { useCustomContext } from "/functions/hooks"

export const SearchClientFromServer = () =>
{
  const input = useRef(null)
  const {updateClient} = useCustomContext(ClientContext)

  const handleFocus = (e) => {
    const parent = e.currentTarget.parentElement
    parent.classList.add('focus')
  } 

  const handleBlur = (e) => {
    const parent = e.currentTarget.parentElement
    parent.classList.remove('focus')
  } 

  function handleGetClient(clientID) 
  {
    // Appeller l'api de l'adbanking pour recup les data

    const data = {
      id: 1,
      folio: clientID,
      type: 'Customer',
      name: 'Abdoul-wahid Hassani',
      nickName: 'Azad',
      gender: 'M',
      contacts: [
        {id: 1, telephone: '3245432', email: 'azad@gmail.com'},
      ],
      locations: [
        {id: 1, region: 'Itsandra', city: 'Dzahan Tsidjé', neighborhood: 'Madinat'}
      ],
    }
    
    updateClient(data)
  }

  const handlKeyUp = (e) => {
    if (e.key === "Enter" || e.key === "Return") {
      handleGetClient(e.currentTarget.value)
    }
  }

  return (
    <div className='gck-search-client'>
      <div className='gck-search-client-input'>
        <input 
          onKeyUp={handlKeyUp} onBlur={handleBlur} onFocus={handleFocus} 
          ref={input} placeholder='Rechercher client par folio' type="text" 
        />
        <Icon 
          onClick={() => handleGetClient(input.current.value)} 
          className="search-link-icon" name="result-search" size={60}
        />
      </div>
    </div>
  )
}

