import { AttestationsRenderer, } from '../components/AttestationsRenderer'
import { useQuery } from '@tanstack/react-query'
import { getAttestationForPawcredit, groupeAttestationByDate } from '../api/attestation'
import { useMemo } from 'react'

export const AttestationsForPawnCredit = function() {
  const { data, status, error } = useQuery({
    queryKey: ['attestation_for_paw_credit'],
    queryFn: () => getAttestationForPawcredit(),
  }) 
  const attestations = useMemo(() => groupeAttestationByDate(data), [data]);

  return <AttestationsRenderer data={attestations} status={status} error={error} />
}
