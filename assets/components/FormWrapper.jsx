
export const FormWrapper = ({children, className}) => {
  return (
    <div className='gck-form-wrapper'>
      <div className={`gck-form ${className}`}>
        {children}
      </div>
    </div>
  )
}

