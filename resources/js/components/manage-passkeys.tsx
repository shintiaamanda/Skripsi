import { KeyRound } from 'lucide-react';
import Heading from '@/components/heading';

export type Props = {
    canManagePasskeys?: boolean;
    passkeys?: Array<{ id: number; name: string }>;
};

export default function ManagePasskeys(props: Props) {
    if (!(props.canManagePasskeys ?? false)) {
        return null;
    }

    return (
        <div className="space-y-6">
            <Heading
                variant="small"
                title="Passkeys"
                description="Manage your passkeys for passwordless sign-in"
            />

            <div className="p-8 text-center">
                <div className="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-muted">
                    <KeyRound className="h-7 w-7 text-muted-foreground" />
                </div>
                <p className="font-medium">No passkeys yet</p>
                <p className="mt-1 text-sm text-muted-foreground">
                    Add a passkey to sign in without a password
                </p>
            </div>
        </div>
    );
}
