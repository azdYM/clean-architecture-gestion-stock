import { forwardRef } from 'react'
import { Link } from "react-router-dom"
import { getAcronyme, substring } from "../functions/string"
import { ClientData } from "./CardClient"
import { useCustomContext } from '../functions/hooks'
import { ClientContext } from '../functions/context'

type ItemResourceProps = {
  client: ClientData,
  clickedCardLink: string 
}

type CardResourceProps = {
	width: string,
	height: string,
}

export const ItemResource = function({children, client, clickedCardLink}: React.PropsWithChildren<ItemResourceProps>) {
	return (
		<article className='gck-card-article'>
			<Link to={clickedCardLink}>
				<div className='article-header'>
					<ClientAvatarRenderer 
						avatar={getAcronyme(client.name)} 
					/>
					<AboutClientRenderer
						name={client.name} 
						folio={client.folio} 
					/>
				</div>
				<div className='article-body'>
					{children}
				</div>
				<div className='article-footer'></div>
			</Link>
		</article>
	)
}

/**
 * Ce composant doit être sur ClientProvider
 */
export const CardResource = forwardRef<HTMLDivElement, React.PropsWithChildren<CardResourceProps>>(function({children, width, height}, ref) {
	const {name, folio} = useCustomContext(ClientContext) as ClientData
	return (
		<div className='gck-card-client gck-card' ref={ref} style={{position: 'fixed', width, height}}>
			<div className="card-client-wrapper">
				<div className="card-header">
					<ClientAvatarRenderer avatar={getAcronyme(name)} />
					<AboutClientRenderer name={name} folio={folio} />
				</div>
				<div className="card-content">
					{children}
				</div>
			</div>
		</div>
	)
})
  
const ClientAvatarRenderer = function({avatar}: {avatar: string})
{
	return (
		<div className="client-avatar-header">
			<span>{avatar}</span>
		</div>
	)
}

const AboutClientRenderer = function({name, folio}: {name: string, folio: number})
{
	return (
		<div className='about-client-header'>
			<span>{substring(name, 20)}</span>
			<span>{`Folio - ${folio}`}</span>
		</div>
	)
}
  