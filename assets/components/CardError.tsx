export const CardError = ({error}: {error: Error|string}) => {
    return (
        <div>
        {typeof(error) === 'string' ? error : error.message}
        </div>
    )
}