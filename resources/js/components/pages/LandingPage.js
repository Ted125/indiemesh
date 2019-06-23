import React from 'react';
import Container from '@material-ui/core/Container';
import Typography from '@material-ui/core/Typography';
import Header from '../layouts/Header';

export default function LandingPage() {
    return (
        <React.Fragment>
            <Header />
            <Container maxWidth="lg">
                <Typography variant="h6">Landing Page</Typography>
            </Container>
        </React.Fragment>
    );
}