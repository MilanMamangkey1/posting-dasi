import AppearanceToggleDropdown from '@/components/appearance-dropdown';
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
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/react';
import {
    BookOpen,
    Folder,
    LayoutGrid,
    PlayCircle,
    Image as ImageIcon,
    FileText,
    Layers,
    MessageSquare,
} from 'lucide-react';
import AppLogo from './app-logo';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'Video Edukasi',
        href: '/konten/video',
        icon: PlayCircle,
    },
    {
        title: 'Galeri Foto',
        href: '/konten/foto',
        icon: ImageIcon,
    },
    {
        title: 'Narasi',
        href: '/konten/narasi',
        icon: FileText,
    },
    {
        title: 'Materi',
        href: '/konten/materi',
        icon: Layers,
    },
    {
        title: 'Konsultasi',
        href: '/konsultasi',
        icon: MessageSquare,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Repository',
        href: 'https://github.com/laravel/react-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#react',
        icon: BookOpen,
    },
];

export function AppSidebar() {
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
                <NavMain items={mainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <div className="mb-3 flex items-center justify-between rounded-lg border border-sidebar-border/60 bg-sidebar-accent/10 px-3 py-2 transition group-data-[collapsible=icon]:justify-center group-data-[collapsible=icon]:border-none group-data-[collapsible=icon]:bg-transparent group-data-[collapsible=icon]:p-0">
                    <span className="text-xs font-semibold text-sidebar-foreground group-data-[collapsible=icon]:hidden">
                        Tema
                    </span>
                    <AppearanceToggleDropdown className="ml-auto group-data-[collapsible=icon]:ml-0" />
                </div>
                <NavFooter items={footerNavItems} className="mt-auto" />
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
