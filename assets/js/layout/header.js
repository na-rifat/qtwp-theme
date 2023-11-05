import Headroom from "headroom.js";

// grab an element
var myElement = document.querySelector("header");
// construct an instance of Headroom, passing the element
var headroom = new Headroom(myElement);
// initialise
headroom.init();

const header = {
    constructor() {
        this.dur = 600;
        this.parent = $(`header`);
        this.el = $(`header`);
        this.toggle = this.el.find(`.toggle`);
        this.nav_area = this.el.find(`.right`);
        this.nav = this.nav_area.find(`nav`);
        this.sidebar_toggle = this.parent.find(`.toggle`);
        this.sidebar = this.parent.find(`.sidebar`);
        this.btn_close_sidebar = this.sidebar.find(`.btn-close`);
        this.sidebar_nav = this.sidebar.find(
            `nav > ul > li.menu-item-has-children`
        );
        this.sidebar_bg = $(`.sidebar-bg`);
        this.lang_menu = this.parent.find(`.lang-menu`);

        this.menuToggle();
        this.openSidebar();
        this.closeSidebar();
        this.sidebarNavigation();
        this.langMenu();
        this.menuAppend();
        this.handleMegaMenu();
    },
    menuToggle() {
        let self = this;
        this.toggle.on(`click`, function (e) {
            e.preventDefault();

            if (self.el.hasClass(`active`)) {
                self.nav_area.fadeOut(0);
                self.el.removeClass(`active`);

                $(`html`).css(`overflow`, `hidden`);
            } else {
                self.el.addClass(`active`);
                self.nav_area.find(`.btn-grp `).css({ display: `none` });
                self.nav_area.fadeIn(600, function (e) {
                    $(this).css({ display: `flex` });
                    self.nav_area.find(`.btn-grp `).css({ display: `flex` });
                });
                $(`html`).css(`overflow`, `auto`);
            }
        });
    },
    openSidebar() {
        let self = this;

        this.sidebar_toggle.on(`click`, function (e) {
            self.sidebar.toggleClass(`open`);
            $(this).toggleClass(`append`);

            self.sidebar_bg.toggleClass(`active`);
            self.sidebar.find(`.menu-item-has-children`).removeClass(`active`);
        });
    },
    closeSidebar() {
        let self = this;

        this.btn_close_sidebar.on(`click`, function (e) {
            self.sidebar.removeClass(`open`);
            self.sidebar_toggle.removeClass(`append`);

            self.sidebar_bg.removeClass(`active`);
        });
    },
    sidebarNavigation() {
        let self = this;

        this.sidebar.find(`.dropdown-menu li`).on(`click`, function (e) {
            e.stopPropagation();

            window.location.href = $(this).find(`a`).attr(`href`);
        });

        this.sidebar_nav.on(`click`, function (e) {
            e.preventDefault();
            let me = $(this);
            let drop_down = me.find(`.dropdown-menu`);

            if (!me.hasClass(`active`)) {
                self.sidebar_nav
                    .removeClass(`active`)
                    .find(`.dropdown-menu`)
                    .slideUp(200);

                setTimeout(() => {
                    drop_down.slideDown(200);
                    me.addClass(`active`);
                }, 200);
            } else {
                drop_down.slideUp(200);
                me.removeClass(`active`);
            }
        });
    },
    langMenu() {
        let me = this;

        me.lang_menu.find(`a`).on(`click`, function (e) {
            e.preventDefault();
            me.lang_menu.find(`.current`).text($(this).find(`span`).text());
        });

        if ($(window).width() <= 1200) {
            me.lang_menu.on(`click`, function (e) {
                $(this).toggleClass(`active`);
            });
        } else {
            me.lang_menu.on(`mouseenter`, function (e) {
                $(this).addClass(`active`);
            });
            me.lang_menu.on(`mouseleave`, function (e) {
                $(this).removeClass(`active`);
            });
        }
    },
    menuAppend() {
        let me = this;

        let menus = $(`.menu-item-has-children`);
        let dropdowns = $(`.dropdown-menu`);
        let dur = 800;

        menus.on(`click`, function (e) {
            e.preventDefault();

            let self = $(this);
            let self_dropdown = self.find(`.dropdown-menu`);

            self.toggleClass(`current`);
            self_dropdown.slideToggle(dur);
        });

        dropdowns.on(`click`, function (e) {
            e.stopPropagation();
        });
    },
    handleMegaMenu() {
        let me = this;
        me.mega_menu = me.parent.find(`.mega-menu`);
        let childs = me.mega_menu.find(`.child-menus .child-menu-wrapper`);
        let images = me.mega_menu.find(`.images img`);

        me.mega_menu.find(`.menu-item`).on(`mouseenter`, function (e) {
            let self = $(this);
            let i = self.index();

            childs.not(childs.eq(i)).fadeOut(0, function (e) {
                childs.eq(i).fadeIn(200);
            });

            images.not(images.eq(i)).fadeOut(0, function (e) {
                images.eq(i).fadeIn(200);
            });
        });

        if ($(window).width() <= 1200) {
            me.mega_menu.find(`.menu-item`).on(`click`, function (e) {
                e.preventDefault();

                let self = $(this);
                // console.log(self.find(`.responsive`).length)

                self.find(`.responsive`).slideToggle(me.dur);
            });

            me.parent.find(`.mega-menu-toggle`).on(`click`, function (e) {
                e.preventDefault();

                let self = $(this);
                self.toggleClass(`expanded`)
                self.find(`.mega-menu`).slideToggle(me.dur);
            });

            me.mega_menu.on(`click`, function (e) { 
                e.stopPropagation();
             })
        }
    },
};

header.constructor();
