import { CardAttestation } from "./CardAttestation"
import { ContentWrapperWithCard } from "./ContentWrapperWithCard"

type CreditWrapperProps = {
  refs: {
    page: React.RefObject<HTMLDivElement>,
    content: React.RefObject<HTMLDivElement>,
    card: React.RefObject<HTMLDivElement>,
  }
  fromMultiAttestation?: boolean,
}

/**
 * Ce composant doit être un enfant d'une AttestationProvider ou AttestationsProvider
 */
export const CreditWrapper = function({children, refs, fromMultiAttestation}: React.PropsWithChildren<CreditWrapperProps>) {
	return (
		<div 
			style={{
				display: 'grid',
				gridTemplateColumns: '1fr 34Opx'
			}}
			>
			<ContentWrapperWithCard 
				componentsRef={{
					pageRef: refs.page, 
					contentRef: refs.content, 
					cardRef: refs.card
				}} 
				positionCard='right'
			>
				<div ref={refs.content}>
					{children}
				</div>
				<CardAttestation
					multiAttestation={fromMultiAttestation ?? false}
					width="340px" height="70vh" 
					ref={refs.card} 
				/>
			</ContentWrapperWithCard>
		</div>
	)
}