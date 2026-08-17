import { Form, Head, router } from '@inertiajs/react';
import { useState } from 'react';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Spinner } from '@/components/ui/spinner';

export default function TwoFactorChallenge() {
    const [showRecoveryInput, setShowRecoveryInput] = useState<boolean>(false);
    const [code, setCode] = useState<string>('');

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        router.post('/two-factor-challenge', showRecoveryInput ? { recovery_code: code } : { code });
    };

    return (
        <>
            <Head title="Two-factor authentication" />

            <div className="space-y-6">
                <form onSubmit={handleSubmit} className="space-y-4">
                    {showRecoveryInput ? (
                        <div className="grid gap-2">
                            <Input
                                name="recovery_code"
                                type="text"
                                placeholder="Enter recovery code"
                                autoFocus
                                required
                                value={code}
                                onChange={(e) => setCode(e.target.value)}
                            />
                        </div>
                    ) : (
                        <div className="grid gap-2">
                            <Input
                                name="code"
                                type="text"
                                placeholder="Enter authentication code"
                                autoFocus
                                required
                                value={code}
                                onChange={(e) => setCode(e.target.value)}
                            />
                        </div>
                    )}

                    <Button type="submit" className="w-full">
                        Continue
                    </Button>

                    <div className="text-center text-sm text-muted-foreground">
                        <button
                            type="button"
                            className="cursor-pointer text-foreground underline"
                            onClick={() => {
                                setShowRecoveryInput(!showRecoveryInput);
                                setCode('');
                            }}
                        >
                            {showRecoveryInput ? 'login using an authentication code' : 'login using a recovery code'}
                        </button>
                    </div>
                </form>
            </div>
        </>
    );
}
