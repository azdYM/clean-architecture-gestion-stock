import { forwardRef } from "react"
import { useCustomContext } from "../functions/hooks"
import { AttestationContext } from "../functions/context"
import { ClientData, Contact, Location } from "./CardClient"
import { isCorporateClient, isIndividualClient } from "../api/user"
import { AttestationContentRenderer } from "./AttestationContent"

export const AttestationToPrint = forwardRef<HTMLDivElement, {}>(function({}, ref) 
{
  const attestation = useCustomContext(AttestationContext)
  if (attestation === null) throw new Error('Attestation non trouvé ! veuillez resseyer plus tard')
	const {client, evaluator} = attestation

  return (
    <div ref={ref}>
      <style type="text/css" media="print">
        {"\
        @page {\ size: landscape;\ }\
        "}
      </style>

      <div className='print'>
        <div className='attestation-print-header'>
          <div className='header-meck-moroni'>
            <div className="logo">

            </div>
            <div className='presentation'>
              <p>Mutuelle d'Epargne et de Crédit ya Komor-Moroni</p>
              <p>B.P 877 Moroni Route de la corniche Moroni Hankounou, Ngazidja  - Union des Comores</p>
              <p>Tel : 773 27 28 / 773 82 83</p>
              <p>Email : contact@meck-moroni.org</p>
            </div>
          </div>
          <HeaderClientInformation client={client}/>
        </div>
        <AttestationContentRenderer env='print' />
        <div className='attestation-print-footer'>
          <div className='print-footer-card'>
            <h3>Emprunteur</h3>
            <span>{client.name}</span>
            <div className='signature'>
              <h3>Signature</h3>
              <div></div>
            </div>
          </div>
          <div className='print-footer-card'>
            <h3>Evaluateur</h3>
            <span>{evaluator.fullname}</span>
            <div className='signature'>
              <h3>Signature</h3>
              <div></div>
            </div>
          </div>
          <div className='print-footer-card'>
            <h3>Superviseur</h3>
            <span>Nom et prénom</span>
            <div className='signature'>
              <h3>Signature</h3>
              <div></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  )
})

const HeaderClientInformation = function ({client}: {client: ClientData}) {
  return (
    <div className='client-information'>
      <ShowGeneralInformation client={client} />
      <ShowContacts contacts={client.contacts} />
      <ShowLocations locations={client.locations} />
    </div>
  )
}

const ShowGeneralInformation = function({client}: {client: ClientData}) {
  const {name, folio} = client
   
  return (
    <div className='information-rows'>
      <div className='information-row'>
        <span>Nom et Prénom</span>
        <span>{name}</span>
      </div>
      <div className='information-row'>
        <span>Folio</span>
        <span>{folio}</span>
      </div>
      {isIndividualClient(client) && (
        <>
          <div className='information-row'>
            <span>Date de naissance</span>
            <span>{client.birthDay}</span>
          </div>
          <div className='information-row'>
            <span>Nin</span>
            <span>{client.nin}</span>
          </div>
          <div className='information-row'>
            <span>Lieu de Naissance</span>
            <span>
              {`
                ${client.birthLocation?.region},  
                ${client.birthLocation?.city}, 
                ${client.birthLocation?.neighborhood} 
              `}
            </span>
          </div>
        </>
      )}
      {isCorporateClient(client) && (
        <>
          <div className='information-row'>
            <span>Forme juridique</span>
            <span>{client.legalForm}</span>
          </div>
          <div className='information-row'>
            <span>Domaine d'activité</span>
            <span>{client.activityDomain}</span>
          </div>
          <div className='information-row'>
            <span>Registre de commerce</span>
            <span>{client.comericialRegistry}</span>
          </div>
        </>
      )}

    </div>
  )
}

const ShowContacts = function({contacts}: {contacts?: Contact[]}) {
  if (contacts === undefined || contacts.length === 0) {
    return (
      <div className='information-row'>
        <span>Contacts</span>
        <span>Auncun contact</span>
      </div>
    )
  }

  return (
    <div className='information-rows'>
      <div className='information-row'>
        <span>Téléphone</span>
        <span>
          {contacts.map(contact => (<span>{contact.telephone}</span>))}
        </span>
      </div>

      <div className='information-row'>
        <span>Email</span>
        <span>
          {contacts[contacts.length].email}
        </span>
      </div>
    </div>
  )
}

const ShowLocations = function({locations}: {locations?: Location[]}) {
  if (locations === undefined || locations.length === 0) {
    return (
      <div className='information-row'>
        <span>Adresse</span>
        <span>Auncune adresse enregistré</span>
      </div>
    )
  }
  const location = locations[locations?.length]
  return (
    <div className='information-rows'>
      <div className='information-row'>
        <span>Adresse</span>
        <span>
          {`
            ${location?.region},  
            ${location?.city}, 
            ${location?.neighborhood} 
          `}
        </span>
      </div>
    </div>
  )
}
