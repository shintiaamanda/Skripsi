import { Link, usePage } from '@inertiajs/react';
import {
    BookOpen,
    Calendar,
    ClipboardList,
    ClipboardCheck,
    FileText,
    FolderGit2,
    Info,
    LayoutGrid,
    Shield,
    ScrollText,
    Users,
    UserCircle,
    BarChart3,
} from 'lucide-react';
import AppLogo from '@/components/app-logo';
import { NavFooter } from '@/components/nav-footer';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import adminRoutes from '@/routes/admin';
import type { NavGroup } from '@/types';

export function AppSidebar() {
    const { auth } = usePage<{ auth: { user: { role: string } } }>().props;
    const role = auth.user?.role;

    const guruBkGroups: NavGroup[] = [
        {
            title: 'Menu Utama',
            items: [
                { title: 'Dashboard', href: dashboard(), icon: LayoutGrid },
            ],
        },
        {
            title: 'Master Data',
            items: [
                { title: 'Akun Pengguna', href: adminRoutes.register.index.url(), icon: Users },
                { title: 'Data Siswa', href: adminRoutes.siswa.index.url(), icon: UserCircle },
                { title: 'Jadwal Layanan', href: adminRoutes.jadwal.index.url(), icon: Calendar },
                { title: 'Tata Tertib', href: adminRoutes.tataTertib.index.url(), icon: ScrollText },
                { title: 'Informasi BK', href: adminRoutes.informasi.index.url(), icon: Info },
            ],
        },
        {
            title: 'Transaksi',
            items: [
                { title: 'Konseling', href: adminRoutes.konseling.index.url(), icon: ClipboardList },
                { title: 'Monitoring', href: adminRoutes.monitoring.index.url(), icon: FileText },
                { title: 'Pelanggaran', href: adminRoutes.pelanggaran.index.url(), icon: Shield },
            ],
        },
        {
            title: 'Laporan',
            items: [
                { title: 'Laporan', href: adminRoutes.laporan.index.url(), icon: BarChart3 },
            ],
        },
    ];

    const siswaGroups: NavGroup[] = [
        {
            title: 'Menu',
            items: [
                { title: 'Dashboard', href: dashboard(), icon: LayoutGrid },
            ],
        },
    ];

    const orangTuaGroups: NavGroup[] = [
        {
            title: 'Menu',
            items: [
                { title: 'Dashboard', href: dashboard(), icon: LayoutGrid },
            ],
        },
    ];

    const kepalaSekolahGroups: NavGroup[] = [
        {
            title: 'Menu',
            items: [
                { title: 'Dashboard', href: dashboard(), icon: LayoutGrid },
                { title: 'Laporan', href: adminRoutes.laporan.index.url(), icon: BarChart3 },
            ],
        },
    ];

    const navGroups: NavGroup[] = match(role, {
        guru_bk: guruBkGroups,
        siswa: siswaGroups,
        orang_tua: orangTuaGroups,
        kepala_sekolah: kepalaSekolahGroups,
    }) ?? guruBkGroups;

    const footerNavItems = [
        {
            title: 'Repository',
            href: 'https://github.com/laravel/react-starter-kit',
            icon: FolderGit2,
        },
        {
            title: 'Documentation',
            href: 'https://laravel.com/docs/starter-kits#react',
            icon: BookOpen,
        },
    ];

    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href={dashboard()} prefetch>
                                <AppLogo />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain groups={navGroups} />
            </SidebarContent>

            <SidebarFooter>
                <NavFooter items={footerNavItems} className="mt-auto" />
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}

function match<T>(value: string, cases: Record<string, T>): T | undefined {
    return cases[value];
}
