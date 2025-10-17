import {
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/react';
import { useEffect, useState } from 'react';

export function NavMain({ items = [] }: { items: NavItem[] }) {
    const page = usePage();
    const [currentHash, setCurrentHash] = useState<string>(() =>
        typeof window !== 'undefined' ? window.location.hash : '',
    );

    useEffect(() => {
        const updateHash = () => {
            setCurrentHash(window.location.hash);
        };

        window.addEventListener('hashchange', updateHash);
        return () => window.removeEventListener('hashchange', updateHash);
    }, []);

    useEffect(() => {
        setCurrentHash(typeof window !== 'undefined' ? window.location.hash : '');
    }, [page.url]);

    return (
        <SidebarGroup className="px-2 py-0">
            <SidebarGroupLabel>Platform</SidebarGroupLabel>
            <SidebarMenu>
                {items.map((item) => {
                    const href =
                        typeof item.href === 'string' ? item.href : item.href.url;
                    const isAnchorLink = href.startsWith('#');
                    const isActive =
                        item.isActive ??
                        (isAnchorLink
                            ? currentHash === href
                            : page.url.startsWith(href));

                    return (
                        <SidebarMenuItem key={item.title}>
                            <SidebarMenuButton
                                asChild
                                isActive={isActive}
                                tooltip={{ children: item.title }}
                            >
                                {isAnchorLink ? (
                                    <a href={href}>
                                        {item.icon && <item.icon />}
                                        <span>{item.title}</span>
                                    </a>
                                ) : (
                                    <Link href={item.href} prefetch>
                                        {item.icon && <item.icon />}
                                        <span>{item.title}</span>
                                    </Link>
                                )}
                            </SidebarMenuButton>
                        </SidebarMenuItem>
                    );
                })}
            </SidebarMenu>
        </SidebarGroup>
    );
}
