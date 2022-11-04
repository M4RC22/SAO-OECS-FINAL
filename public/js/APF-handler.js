function populateOrganizer(){
    return{

        currentUSerOrgs:[],
        displayMembers: [],

        loadOrgs(orgList){
            let orgs = JSON.parse(orgList)
            
            orgs.forEach(org => {
                this.currentUSerOrgs.push({
                    id: org.id,
                    orgName: org.org_name
                });
            });
        },


        loadMembers(memberList){
            let members = JSON.parse(memberList)
            
            this.currentUSerOrgs.forEach(org => {
                members.forEach(member => {
                    if(org.id === member.organization_id){
                        this.displayMembers.push({
                            orgName: org.orgName,
                            id: member.id,
                            userId: member.user_id,
                            orgId: member.organization_id,
                            name: member.name,
                        })
                    }
                })
            });
            this.populateMembers(this.$refs.organization);
        },

        populateMembers($el, id = null){
            let getMembers = this.displayMembers.filter(item => {
                if(item.orgId === $el.value){
                    return item
                }
            })

            //Remove All option
            while (this.$refs.members.length > 0) {
                this.$refs.members.remove(0);
            }

            //Append New Option
            getMembers.forEach(member => {
                let newOption = new Option(member.name, member.id);
                this.$refs.members.add(newOption);
            })

            if(id != null){
                this.$refs.members.value = id;
            }
        },

        edit(id){
            this.populateMembers(this.$refs.organization, id)
        }
    }
}