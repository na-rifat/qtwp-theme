const footer = {
    init() {
        this.parent = $(`footer`);
        this.menu_toggle = this.parent.find(`.fcol h3`);

        this.mobileAccordion();
    },
    mobileAccordion() {
        let me = this;

        me.menu_toggle.on(`click`, function (e) {
            let self = $(this);

            self.parents(`.fcol`).find(`.menu-col`).slideToggle(600);
            self.toggleClass(`active`);
        });
    },
};

footer.init();
