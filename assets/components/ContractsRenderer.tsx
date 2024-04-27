import { CreditData } from "../api/credit"
import { formatNumber, formatRelativeDate } from "../functions/format"
import { routes } from "../functions/links"
import { getWorkflowPlaceProperties } from "./AttestationsRenderer"
import { ItemResource } from "./CardAndItemResource"
import { CardError } from "./CardError"
import { ContainerSectionRenderer } from "./SectionRenderer"

type ContractsRendererProps = {
	data: CreditData[]|undefined,
	status: ('loading'|'error'|'success'),
	error: unknown
}

export const ContractsRenderer = function({data, status, error}: ContractsRendererProps) {
	return (
		<ContainerSectionRenderer>
			{status === 'loading' && <p>Loading...</p>}
			{error 
				? <CardError error={error as Error} />
				: (
					data?.map((item, index) => 
						<ItemCredit key={index} credit={item} />
					)
				)
			}
		</ContainerSectionRenderer>
	)
}

const ItemCredit = function({credit}: {credit: CreditData}) {
	const currentPlace = getWorkflowPlaceProperties(credit.currentPlace)

	return (
		<ItemResource
			client={credit.folder.client}
			clickedCardLink={`${routes.showCredit.replace(':id', `${credit.id}`)}`}
		>
			<span>{`Contrat de ${formatNumber(credit.capital)} KMF`}</span>
      {credit.currentPlace !== 'created' &&
        <span className={currentPlace.className}>{currentPlace.label}</span>
      }
      <p className='time'>
        {`Mise à jour ${formatRelativeDate(new Date(credit.updatedAt)) }`}
      </p>
		</ItemResource>
	)
}