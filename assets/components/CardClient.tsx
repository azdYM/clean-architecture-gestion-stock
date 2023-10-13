import { forwardRef } from "react"
import { useCustomContext } from "../functions/hooks"
import { ClientContext, ClientSearchResult } from "../functions/context"
import { getAcronyme } from "../functions/string"

type CardClientProps = {width: string, height: string}

export const CardClient = forwardRef<HTMLDivElement, CardClientProps>(({width = '280px', height = '90vh'}, ref) => 
{
	const {client} = useCustomContext(ClientContext) as ClientSearchResult
	return (
		<div className='gck-card-client gck-card' ref={ref} style={{position: 'fixed', width, height}}>
			{client !== null && 
				<div className="card-client-wrapper">
					<div className="card-header">
						<span className="avatar-client">{getAcronyme(client.name)}</span>
						<div className="about-client">
							<span>{client.name}</span>
							<span>{`Folio - ${client.folio}`}</span>
						</div>
					</div>
					<div className="card-content"></div>
				</div>
			}
		</div>
	)
})