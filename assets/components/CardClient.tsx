import { forwardRef } from "react"
import { useCustomContext } from "../functions/hooks"
import { ClientContext } from "../functions/context"
import { getAcronyme } from "../functions/string"


export type ClientData = {
  id: number,
  name: string,
  folio: number
}

type CardClientProps = {width: string, height: string}

export const CardClient = forwardRef<HTMLDivElement, CardClientProps>(({width = '280px', height = '90vh'}, ref) => 
{
	const {name, folio} = useCustomContext(ClientContext) as ClientData
	return (
		<div className='gck-card-client gck-card' ref={ref} style={{position: 'fixed', width, height}}>
			<div className="card-client-wrapper">
				<div className="card-header">
					<span className="avatar-client">{getAcronyme(name)}</span>
					<div className="about-client">
						<span>{name}</span>
						<span>{`Folio - ${folio}`}</span>
					</div>
				</div>
				<div className="card-content"></div>
			</div>
		</div>
	)
})