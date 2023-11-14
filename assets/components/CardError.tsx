
export const CardError = ({error}: {error: Error}) => {
    return (
        <div>
        {error.message}
        </div>
    )
}