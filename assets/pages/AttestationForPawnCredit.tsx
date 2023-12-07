import { AttestationsRenderer, } from '../components/AttestationsBodySection'
import { useQuery } from '@tanstack/react-query'
import { getAttestationForPawcredit } from '../api/attestation'

export const AttestationsForPawnCredit = function() {
  const { data, status, error } = useQuery({
    queryKey: ['attestation_for_paw_credit'],
    queryFn: () => getAttestationForPawcredit(),
  }) 

  return (
    <AttestationsRenderer data={data} status={status} error={error} />
  )
}
