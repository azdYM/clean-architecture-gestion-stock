import { forwardRef } from "react"
import { ClientContext } from "/functions/context"
import { useCustomContext } from "/functions/hooks"
import { getAcronyme } from "/functions/string"

export const CardClient = forwardRef(({width = '280px', height = '90vh'}, ref) => 
{
	const {client} = useCustomContext(ClientContext)
	const style = {
		position: 'fixed',
		width,
		height,
	}

	return (
		<gck-card-client ref={ref} style={style} class='gck-card'>
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
		</gck-card-client>
	)
})