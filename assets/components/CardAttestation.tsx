import { forwardRef } from 'react'
import { AttestationContext, AttestationsContext } from "../functions/context"
import { useCustomContext } from "../functions/hooks"
import { getAcronyme } from '../functions/string'
import { ClientData } from './CardClient'
import { CardError } from './CardError'


type CardAttestationProps = {
	width?: string,
	height?: string,
	multiAttestation?: boolean
}

export const CardAttestation = forwardRef<HTMLDivElement, CardAttestationProps>(function({multiAttestation, width, height}, ref) {
	const client = getClientFromAttestation(multiAttestation)

	if (client === null) {
		return <CardError error={new Error("Ce page ne peut pas sans le client")} />
	}

	return (
		<div className='gck-card-client gck-card' ref={ref} style={{position: 'fixed', width, height}}>
			<div className="card-client-wrapper">
				<div className="card-header">
					<span className="avatar-client">{getAcronyme(client?.name)}</span>
					<div className="about-client">
						<span>{client?.name}</span>
						<span>{`Folio - ${client?.folio}`}</span>
					</div>
				</div>
				<div className="card-content"></div>
			</div>
		</div>
	)
})

const getClientFromAttestation = function(multiAttestation?: boolean) {
	let client: ClientData|null = null

	if (multiAttestation) {
		const attestations = useCustomContext(AttestationsContext)
		if (attestations) {
			client = attestations[0].client
		}
	}

	else {
		client = useCustomContext(AttestationContext)?.client ?? null
	}

	return client
}