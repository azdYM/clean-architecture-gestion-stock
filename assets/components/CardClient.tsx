import { forwardRef } from "react"
import { CardResource } from "./CardAndItemResource"


export type Location = {
	id: number,
	region?: string,
	city?: string,
	neighborhood?: string
}

export type Contact = {
	id: number,
	telephone?: string,
	email?: string
}

export type Individual = {
	nickname?: string,
	gender?: ('M'|'F'),
	nin?: string,
	birthDay?: string,
	birthLocation?: Location
}

export type Corporate = {
	legalForm?: string,
    activityDomain?: string,
    comericialRegistry?: string
}

export type ClientData = {
  id: number,
  name: string,
  folio: number,
  locations?: Location[],
  contacts?: Contact[]
} & Individual & Corporate

type CardClientProps = {width: string, height: string}

export const CardClient = forwardRef<HTMLDivElement, CardClientProps>(({width = '280px', height = '90vh'}, ref) => 
{
	return (
		<CardResource
			width={width}
			height={height}
			ref={ref}
		>
			Salut les gens
		</CardResource>
	)
})