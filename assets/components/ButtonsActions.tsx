
type ButtonsActionsProps = {
	onClick: CallableFunction, 
	text?: string,
	className?: string
	disabled?: boolean
}

export const EditRenderer = function({onClick, text}: ButtonsActionsProps)
{

	return (
		<button 
			onClick={() => onClick()}
			className='btn-update' 
		>
			{text ?? 'Modifier'}
		</button>
	)
}

export const ValidateRenderer = function({onClick, text}: ButtonsActionsProps) 
{

	return (
		<button 
			onClick={() => onClick()}
			className='btn-validate'
		>
			{text ?? 'Valider'}
		</button>
	)
}

export const PrintRenderer = function({onClick, text}: ButtonsActionsProps) {

	return (
		<button 
			onClick={() => onClick()}
			className='btn-print'
		>
			{text ?? 'Imprimer'}
		</button>
	)
}

export const CreateRenderer = function({onClick, text, className}: ButtonsActionsProps) {

	return (
		<button 
			onClick={() => onClick()}
			className={`btn-create ${className ?? ''}`}
		>
			{text ?? 'Créer'}
		</button>
	)
}

export const ActionRenderer = function({onClick, text, className}: ButtonsActionsProps) {

	return (
		<button 
			onClick={() => onClick()}
			className={`btn-approval ${className ?? ''}`}
		>
			{text ?? 'Approuver'}
		</button>
	)
}
