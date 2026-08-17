import { ShieldCheck } from 'lucide-react';
import Heading from '@/components/heading';
import { Button } from '@/components/ui/button';

export type Props = {
    canManageTwoFactor?: boolean;
    requiresConfirmation?: boolean;
    twoFactorEnabled?: boolean;
};

export default function ManageTwoFactor(props: Props) {
    if (!(props.canManageTwoFactor ?? false)) {
        return null;
    }

    return (
        <div className="space-y-6">
            <Heading
                variant="small"
                title="Two-factor authentication"
                description="Manage your two-factor authentication settings"
            />
            <div className="flex flex-col items-start justify-start space-y-4">
                <p className="text-sm text-muted-foreground">
                    Two-factor authentication is not currently available.
                </p>
            </div>
        </div>
    );
}
