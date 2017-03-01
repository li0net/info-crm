<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    var sid = '{{ $superOrganization->super_organization_id or "" }}'; // set super organization
    var orgId = '{{ $organization->organization_id or "" }}'; // set super organization
</script>
<script src="{{asset('js/widget.js')}}"></script>
