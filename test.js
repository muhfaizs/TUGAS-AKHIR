function bidanProfile() {
    const puskesmasList = [];
    const userPuskesmasId = '';
    let initKabId = '';
    if (userPuskesmasId) {
        const found = puskesmasList.find(p => p.id == userPuskesmasId);
        if (found) initKabId = found.kabupaten_id;
    }
    
    return {
        showPassword: false,
        kabupatenList: [],
        puskesmasList: puskesmasList,
        kabupaten_id: initKabId,
        puskesmas_id: userPuskesmasId,
        get filteredPuskesmas() {
            if (!this.kabupaten_id) return [];
            return this.puskesmasList.filter(p => p.kabupaten_id == this.kabupaten_id);
        }
    }
}

bidanProfile();
